<?php

namespace Domain
{

    use Domain\Handler\Method\MessageNameResolver;
    use Domain\Handler\SimpleResolver;
    use Domain\Message\MessageClassResolver;
    use Domain\MessageResolver;

    abstract class BusBuilder
    {

        /**
         * @var Middleware[]
         */
        protected $middlewares = [];

        /**
         * @var MessageResolver
         */
        private $messageResolver;

        /**
         * @var HandlerResolver
         */
        private $handlerResolver;

        /**
         * @var MethodResolver
         */
        private $handlerMethodResolver;

        /**
         * Create new builder instance
         *
         * @return static
         */
        public static function make()
        {
            return new static();
        }

        /**
         * @param Middleware[] ...$middleware
         *
         * @return static
         */
        public function using($middleware)
        {
            // TODO : merge by value
            $this->middlewares = array_merge($this->middlewares, func_get_args());
            return $this;
        }

        /**
         * Register message name resolver
         *
         * @param MessageResolver $resolver
         *
         * @return static
         */
        public function usingMessageResolver(MessageResolver $resolver)
        {
            $this->messageResolver = $resolver;
            return $this;
        }

        /**
         * Returns message name resolver
         *
         * @return MessageResolver
         */
        public function getMessageResolver()
        {
            if ($this->messageResolver === null) {
                return new MessageClassResolver();
            }
            return $this->messageResolver;
        }

        /**
         * Register handler instance resolver
         *
         * @param HandlerResolver $resolver
         *
         * @return static
         */
        public function usingHandlerResolver(HandlerResolver $resolver)
        {
            $this->handlerResolver = $resolver;
            return $this;
        }

        /**
         * Returns HandlerResolver instance
         *
         * @return HandlerResolver
         */
        protected function getHandlerResolver()
        {
            if ($this->handlerResolver === null) {
                return new SimpleResolver();
            }
            return $this->handlerResolver;
        }

        /**
         * Register handler method callable resolver
         *
         * @param MethodResolver $resolver
         *
         * @return static
         */
        public function usingHandlerMethodResolver(MethodResolver $resolver)
        {
            $this->handlerMethodResolver = $resolver;
            return $this;
        }

        /**
         * Returns MethodResolver
         *
         * @return MethodResolver
         */
        protected function getHandlerMethodResolver()
        {
            if ($this->handlerMethodResolver === null) {
                return new MessageNameResolver();
            }
            return $this->handlerMethodResolver;
        }

    }

}

