<?php
namespace SimpleAclTest\Role;

use PHPUnit_Framework_TestCase;

use SimpleAcl\Role;
use SimpleAcl\Role\RoleAggregate;


class RoleAggregateTest extends PHPUnit_Framework_TestCase
{
    public function testSetAndGetRoles()
    {
        $roles = array('One' => new Role('One'), 'Tow' => new Role('Tow'));

        $user = new RoleAggregate();

        $this->assertEquals(0, count($user->getRoles()));

        $user->setRoles($roles);

        $this->assertEquals($roles, $user->getRoles());

        $this->assertEquals(2, count($user->getRoles()));
    }

    public function testRoleAdd()
    {
        $user = new RoleAggregate();

        $role1 = new Role('One');
        $role2 = new Role('Tow');

        $this->assertEquals(0, count($user->getRoles()));

        $user->addRole($role1);
        $user->addRole($role2);

        $this->assertEquals(2, count($user->getRoles()));

        $this->assertEquals(array('One' => $role1, 'Tow' => $role2), $user->getRoles());
    }

    public function testRemoveRoles()
    {
        $user = new RoleAggregate();

        $role1 = new Role('One');
        $role2 = new Role('Tow');

        $this->assertEquals(0, count($user->getRoles()));

        $user->addRole($role1);
        $user->addRole($role2);

        $this->assertEquals(2, count($user->getRoles()));

        $user->removeRoles();

        $this->assertEquals(0, count($user->getRoles()));

        $this->assertNull($user->getRole('One'));
        $this->assertNull($user->getRole('Tow'));
    }

    public function testRemoveRole()
    {
        $user = new RoleAggregate();

        $role1 = new Role('One');
        $role2 = new Role('Tow');

        $this->assertEquals(0, count($user->getRoles()));

        $user->addRole($role1);
        $user->addRole($role2);

        $this->assertEquals(2, count($user->getRoles()));

        $user->removeRole('One');
        $this->assertEquals(1, count($user->getRoles()));
        $this->assertEquals($role2, $user->getRole('Tow'));

        $user->removeRole('UnDefinedTow');
        $this->assertEquals(1, count($user->getRoles()));

        $user->removeRole('Tow');
        $this->assertEquals(0, count($user->getRoles()));
    }

    public function testAddObjectWithSameName()
    {
        $user = new RoleAggregate();

        $role1 = new Role('One');
        $role2 = new Role('One');

        $user->addRole($role1);
        $user->addRole($role2); // last added wins

        $this->assertEquals(1, count($user->getRoles()));
        $this->assertSame($user->getRole('One'), $role2);
    }
}