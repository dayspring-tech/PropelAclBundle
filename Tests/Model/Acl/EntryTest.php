<?php

/**
 * This file is part of the PropelAclBundle package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */
namespace Propel\Bundle\PropelAclBundle\Tests\Model\Acl;

use Propel\Bundle\PropelAclBundle\Model\Acl\Entry as ModelEntry;
use Propel\Bundle\PropelAclBundle\Model\Acl\SecurityIdentity;
use Propel\Bundle\PropelAclBundle\Tests\TestCase;

/**
 * @author Toni Uebernickel <tuebernickel@gmail.com>
 */
class EntryTest extends TestCase
{
    public function testToAclEntry()
    {
        $acl = $this->getMock('Propel\Bundle\PropelAclBundle\Security\Acl\Domain\AuditableAcl', array(), array(), '', false, false);
        $entry = $this->createModelEntry();

        $aclEntry = ModelEntry::toAclEntry($entry, $acl);
        $this->assertInstanceOf('Propel\Bundle\PropelAclBundle\Security\Acl\Domain\Entry', $aclEntry);
        $this->assertSame($acl, $aclEntry->getAcl());
        $this->assertEquals(42, $aclEntry->getId());
        $this->assertTrue($aclEntry->isAuditFailure());
        $this->assertFalse($aclEntry->isAuditSuccess());
        $this->assertEquals('all', $aclEntry->getStrategy());
        $this->assertTrue($aclEntry->isGranting());
        $this->assertEquals(64, $aclEntry->getMask());

        return $aclEntry;
    }

    /**
     * @depends testToAclEntry
     */
    public function testToAclEntryFieldEntry()
    {
        $acl = $this->getMock('Propel\Bundle\PropelAclBundle\Security\Acl\Domain\AuditableAcl', array(), array(), '', false, false);
        $entry = $this->createModelEntry();
        $entry->setFieldName('name');

        $aclEntry = ModelEntry::toAclEntry($entry, $acl);
        $this->assertInstanceOf('Propel\Bundle\PropelAclBundle\Security\Acl\Domain\FieldEntry', $aclEntry);
    }

    /**
     * @depends testToAclEntry
     */
    public function testFromAclEntry($aclEntry)
    {
        $modelEntry = ModelEntry::fromAclEntry($aclEntry);

        $this->assertInstanceOf('Propel\Bundle\PropelAclBundle\Model\Acl\Entry', $modelEntry);
        $this->assertEquals(42, $modelEntry->getId());
        $this->assertTrue($modelEntry->getAuditFailure());
        $this->assertFalse($modelEntry->getAuditSuccess());
        $this->assertEquals('all', $modelEntry->getGrantingStrategy());
        $this->assertTrue($modelEntry->getGranting());
        $this->assertEquals(64, $modelEntry->getMask());
    }

    protected function createModelEntry()
    {
        $entry = new ModelEntry();
        $entry
            ->setId(42)
            ->setAclClass($this->getAclClass())
            ->setSecurityIdentity(SecurityIdentity::fromAclIdentity($this->getRoleSecurityIdentity()))
            ->setAuditFailure(true)
            ->setAuditSuccess(false)
            ->setGrantingStrategy('all')
            ->setGranting(true)
            ->setMask(64)
        ;

        return $entry;
    }
}