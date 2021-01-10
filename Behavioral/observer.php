<?php

/* OBSERVER PATTERN defines a one-to-many dependency between objects so that when one object state,
* all of its dependents are notified and updated automatically.
*/

/** PUBLISHER */
abstract class Publisher {
    private array $subscribers = [];

    public function subscribe(int $typeSubscription, Subscriber $subscriber): void {
        $this->subscribers[$typeSubscription][] = $subscriber;
    }

    public function publish(int $typeSubscription): void {
        if (!isset($this->subscribers[$typeSubscription])) {
            return;
        }

        foreach ($this->subscribers[$typeSubscription] as $subscriber) {
            $subscriber($this);
        }
    }
}

class User extends Publisher {
    public const USER_IS_LOGGED     = 0;
    public const USER_IS_REGISTERED = 1;

    private string $name;
    private string $email;

    public function __construct(string $name, string $email) {
        $this->name  = $name;
        $this->email = $email;
    }

    public function name(): string {
        return $this->name;
    }

    public function email(): string {
        return $this->email;
    }

    public function login() {
        echo "I am {$this->name} and I am logged.\n";
        sleep(2);
        $this->publish(self::USER_IS_LOGGED);
    }

    public function register() {
        echo "I am {$this->name} and I am registered.\n";
        sleep(2);
        $this->publish(self::USER_IS_REGISTERED);
    }
}

/** SUBSCRIBERS */
abstract class Subscriber {
    private Publisher $publisher;

    public function __construct(int $typeSubscription, Publisher $publisher) {
        $this->publisher = $publisher;
        $publisher->subscribe($typeSubscription, $this);
    }

    abstract public function __invoke(Publisher $publisher): void;
}

class UserRegisteredEmailService extends Subscriber {
    public function __invoke(Publisher $user): void {
        echo "Send Email because user {$user->name()} is registered\n";
    }
}

class UserRegisteredAddPointsService extends Subscriber {
    public function __invoke(Publisher $user): void {
        echo "Add points to user because {$user->name()} is registered\n";
    }
}

class UserLoggedSendNotification extends Subscriber {
    public function __invoke(Publisher $user): void {
        echo "Send notification because {$user->name()} is logged\n";
    }
}

/**
 * MAIN
 */
$joel                           = new User('Joel', 'joel@gmail.com');
$userRegisteredEmailService     = new UserRegisteredEmailService(User::USER_IS_REGISTERED, $joel);
$userRegisteredAddPointsService = new UserRegisteredAddPointsService(User::USER_IS_REGISTERED, $joel);
$userLoggedNotification         = new UserLoggedSendNotification(User::USER_IS_LOGGED, $joel);

$joel->register();
echo "\n-----------------\n";
sleep(3);
$joel->login();
