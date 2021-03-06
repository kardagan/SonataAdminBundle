<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Mapper;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Builder\BuilderInterface;

/**
 * This class is used to simulate the Form API.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
abstract class BaseMapper
{
    /**
     * @var AdminInterface
     */
    protected $admin;

    /**
     * @var BuilderInterface
     */
    protected $builder;

    /**
     * @var bool|null
     */
    protected $apply;

    public function __construct(BuilderInterface $builder, AdminInterface $admin)
    {
        $this->builder = $builder;
        $this->admin = $admin;
    }

    /**
     * @return AdminInterface
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    abstract public function get($key);

    /**
     * @param string $key
     *
     * @return bool
     */
    abstract public function has($key);

    /**
     * @param string $key
     *
     * @return $this
     */
    abstract public function remove($key);

    // To be uncommented on 4.0.
    /**
     * Returns configured keys.
     *
     * @return string[]
     */
    //abstract public function keys();

    /**
     * @param array $keys field names
     *
     * @return $this
     */
    abstract public function reorder(array $keys);

    /**
     * Only nested add if the condition match true.
     *
     * @param bool $bool
     *
     * @throws \RuntimeException
     *
     * @return $this
     */
    public function ifTrue($bool)
    {
        if (null !== $this->apply) {
            throw new \RuntimeException('Cannot nest ifTrue or ifFalse call');
        }

        $this->apply = (true === $bool);

        return $this;
    }

    /**
     * Only nested add if the condition match false.
     *
     * @param bool $bool
     *
     * @throws \RuntimeException
     *
     * @return $this
     */
    public function ifFalse($bool)
    {
        if (null !== $this->apply) {
            throw new \RuntimeException('Cannot nest ifTrue or ifFalse call');
        }

        $this->apply = (false === $bool);

        return $this;
    }

    /**
     * @return $this
     */
    public function ifEnd()
    {
        $this->apply = null;

        return $this;
    }
}
