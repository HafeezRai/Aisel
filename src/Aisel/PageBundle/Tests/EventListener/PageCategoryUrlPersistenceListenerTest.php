<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\Tests\EventListener;

use Aisel\ResourceBundle\Tests\AbstractWebTestCase;
use Aisel\PageBundle\Entity\Category;

/**
 * PageCategoryUrlPersistenceListenerTest
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
 */
class PageCategoryUrlPersistenceListenerTest extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testDuplicatedUrlThrowsError()
    {
        $urlText = 'page-category-test-meta-url';
        $this->setExpectedException(
            'LogicException', 'Given URL already exists'
        );

        // Create Page Category 1
        $category1 = new Category();
        $category1->setLocale('en');
        $category1->setTitle('...');
        $category1->setDescription('...');
        $category1->setStatus(true);
        $category1->setMetaUrl($urlText);

        $this->em->persist($category1);
        $this->em->flush();

        // Create Page Category 2
        $category2 = new Category();
        $category2->setLocale('en');
        $category2->setTitle('...');
        $category2->setDescription('...');
        $category2->setStatus(true);
        $category2->setMetaUrl($urlText);

        $this->em->persist($category2);
        $this->em->flush();

        // Delete Page Category 1
        $category1 = $this->em
            ->getRepository('Aisel\PageBundle\Entity\Category')
            ->findOneBy(['metaUrl' => $urlText]);

        $this->em->remove($category1);
        $this->em->flush();
    }

}
