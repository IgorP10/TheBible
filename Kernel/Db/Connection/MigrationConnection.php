<?php

namespace Kernel\Db\Connection;

class MigrationConnection extends Orchestrator
{
    protected function connectionName(): string
    {
        return 'default';
    }
}
