<?php

declare(strict_types=1);

namespace App\Command;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateDynamoDbSessionsTableCommand extends Command
{
    public function __construct(
        private readonly DynamoDbClient $dynamoDbClient,
        private readonly string $sessionsTableName,
    )
    {
        parent::__construct('dynamodb:create-sessions-table');

        $this->setDescription('Creates the sessions table');

        $this->addOption(
            'force',
            'f',
            InputOption::VALUE_NONE,
            'Delete existing matching schema (if present)'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $isForce = $input->getOption('force');

        $output->writeln(\sprintf('Creating DynamoDB sessions table (force: %s)', $isForce ? 'true' : 'false'));

        if ($isForce) {
            $this->dropTable($this->sessionsTableName);
        }

        $params = [
            'TableName' => $this->sessionsTableName,
            'KeySchema' => [
                [
                    'AttributeName' => 'id',
                    'KeyType' => 'HASH'  //Partition key
                ]
            ],
            'AttributeDefinitions' => [
                [
                    'AttributeName' => 'id',
                    'AttributeType' => 'S'
                ]
            ],
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => 5,
                'WriteCapacityUnits' => 5
            ]
        ];

        try {
            $result = $this->dynamoDbClient->createTable($params);
            echo 'Created table.  Status: ' .
                $result['TableDescription']['TableStatus'] . "\n";

        } catch (DynamoDbException $e) {
            echo "Unable to create table:\n";
            echo $e->getMessage() . "\n";
        }

        return Command::SUCCESS;
    }

    private function dropTable(string $tableName): void
    {
        try {
            $this->dynamoDbClient->deleteTable(['TableName' => $tableName]);
        } catch (\Exception $exception) {
            echo 'FAILED: ' . $exception->getMessage();
        }
    }
}
