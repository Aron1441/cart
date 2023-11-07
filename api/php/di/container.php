<?php
namespace di;
use ReflectionClass;

class Container
{
    private array $objects = [];
    private mixed $args;
    public function has(string $id): bool
    {
        return isset($this->objects[$id]) || class_exists($id);
    }

    public function get(string $id, ...$argss): mixed
    {
        if(!empty($argss)) {
            $this->args = $argss;
        }

//        empty($args)
//        $a = \Closure::fromCallable([$this, 'prepareObject']);
//        $b = $a->bindTo();
        return $this->prepareObject($id);
    }

    private function prepareObject(string $class): object
    {
        $classReflector = new ReflectionClass($class);
        // Получаем рефлектор конструктора класса, проверяем - есть ли конструктор
        // Если конструктора нет - сразу возвращаем экземпляр класса
        $constructReflector = $classReflector->getConstructor();
        if (empty($constructReflector)) {
            return new $class;
        }

        // Получаем рефлекторы аргументов конструктора
        // Если аргументов нет - сразу возвращаем экземпляр класса
        $constructArguments = $constructReflector->getParameters();
        if (empty($constructArguments)) {
            return new $class;
        }

        // Перебираем все аргументы конструктора, собираем их значения
        $args = [];
        foreach ($constructArguments as $argument) {
            $argumentTypeName = $argument->getType()->getName();
            $argumentType = $argument->getType();

            if ($argumentType !== null && $argumentType->isBuiltin()) {
//                if (!class_exists($argumentTypeName)) {
                return new $class(...$args, ...$this->args);
//                }
            }
            // Получаем тип аргумента
            $argumentType = $argument->getType()->getName();

            // Получаем сам аргумент по его типу из контейнера
            $args[$argument->getName()] = $this->get($argumentType);
        }

        // И возвращаем экземпляр класса со всеми зависимостями
        return new $class(...$args);
    }
}