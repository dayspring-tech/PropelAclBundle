<?php

/**
 * This file is part of the PropelAclBundle package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */
namespace Propel\Bundle\PropelAclBundle\Tests\Model\Acl;

use Propel\Bundle\PropelAclBundle\Model\Acl\AclClass;
use Propel\Bundle\PropelAclBundle\Model\Acl\AclClassPeer;
use Propel\Bundle\PropelAclBundle\Tests\TestCase;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

/**
 * @author Toni Uebernickel <tuebernickel@gmail.com>
 */
class AclClassTest extends TestCase
{
    public function testFromAclObjectIdentity()
    {
        $type = 'Merchant';

        $aclClass = AclClass::fromAclObjectIdentity(new ObjectIdentity(5, $type), $this->con);
        $this->assertInstanceOf('Propel\Bundle\PropelAclBundle\Model\Acl\AclClass', $aclClass);
        $this->assertEquals($type, $aclClass->getType());

        $dbEntry = AclClassPeer::doSelectOne(new \Criteria(), $this->con);
        $this->assertInstanceOf('Propel\Bundle\PropelAclBundle\Model\Acl\AclClass', $dbEntry);
        $this->assertEquals($type, $dbEntry->getType());

        $this->assertEquals($dbEntry->getId(), $aclClass->getId());
    }
}
