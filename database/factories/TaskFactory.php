<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'priority' => $this->faker->randomElement(TaskPriority::cases())->value,
            'status' => $this->faker->randomElement(TaskStatus::cases())->value,
            'due_date' => CarbonImmutable::now()->addDays($this->faker->numberBetween(1, 30)),
        ];
    }

    public function withName(string $name): static
    {
        return $this->state([
            'name' => $name,
        ]);
    }

    public function withDescription(?string $description): static
    {
        return $this->state([
            'description' => $description,
        ]);
    }

    public function withPriority(TaskPriority $priority): static
    {
        return $this->state([
            'priority' => $priority->value,
        ]);
    }

    public function withStatus(TaskStatus $status): static
    {
        return $this->state([
            'status' => $status->value,
        ]);
    }

    public function withDueDate(CarbonImmutable $dueDate): static
    {
        return $this->state([
            'due_date' => $dueDate,
        ]);
    }
}
