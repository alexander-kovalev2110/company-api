<?php
// src/Command/DebugJwtCommand.php
namespace App\Command;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsCommand(
    name: 'app:jwt',
    description: 'Generate a JWT token for debugging'
)]
class DebugJwtCommand extends Command
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // создаём пользователя “на лету” без БД
        $user = new class implements UserInterface {
            public function getRoles(): array { return ['ROLE_USER']; }
            public function eraseCredentials(): void {}   // ⚡ обязательно void
            public function getUserIdentifier(): string { return 'debug@local'; }
        };

        $token = $this->jwtManager->create($user);

        $output->writeln("DEBUG JWT TOKEN:");
        $output->writeln($token);

        return Command::SUCCESS;
    }
}