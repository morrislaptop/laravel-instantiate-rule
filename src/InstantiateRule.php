<?php

namespace Morrislaptop\LaravelInstantiateRule;

use Illuminate\Contracts\Validation\Rule;
use Throwable;

class InstantiateRule implements Rule
{
    private string $message;

    /**
     * @param  class-string  $className
     */
    public function __construct(private string $className, private ?string $constructorMethod = null)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $constructorMethod = $this->constructorMethod;

            if ($constructorMethod) {
                $this->className::$constructorMethod(...(array) $value);
            } else {
                new $this->className(...(array) $value);
            }

            return true;
        } catch (Throwable $t) {
            $this->message = $t->getMessage();

            return false;
        }
    }

    public function message()
    {
        return $this->message;
    }
}
