<?php

namespace Jackalope\NodeType;

use Jackalope\Factory;
use Jackalope\TestCase;
use PHPCR\Version\OnParentVersionAction;

class PropertyDefinitionTest extends TestCase
{
    private $defaultData = [
        'declaringNodeType' => 'nt:unstructured',
        'name' => 'foo',
        'isAutoCreated' => false,
        'isMandatory' => false,
        'isProtected' => false,
        'onParentVersion' => OnParentVersionAction::COPY,
        'requiredType' => 'binary',
        'multiple' => false,
        'fullTextSearchable' => false,
        'queryOrderable' => false,
        'valueConstraints' => [],
        'availableQueryOperators' => [],
        'defaultValues' => '',
    ];

    public function testCreateFromArray()
    {
        $factory = $this->createMock(Factory::class);
        $nodeTypeManager = $this->getNodeTypeManagerMock();
        $propType = new PropertyDefinition($factory, $this->defaultData, $nodeTypeManager);

        $this->assertEquals('foo', $propType->getName());
        $this->assertFalse($propType->isAutoCreated());
        $this->assertFalse($propType->isMandatory());
        $this->assertFalse($propType->isProtected());
        $this->assertEquals(OnParentVersionAction::COPY, $propType->getOnParentVersion());
        $this->assertEquals('binary', $propType->getRequiredType());
        $this->assertFalse($propType->isMultiple());
        $this->assertFalse($propType->isQueryOrderable());
        $this->assertFalse($propType->isFullTextSearchable());
    }

    public function testGetDeclaringNodeType()
    {
        $nodeType = $this->getMockBuilder(NodeTypeDefinition::class)
            ->setMethods([])
            ->setConstructorArgs([])
            ->setMockClassName('')
            ->disableOriginalConstructor()
        ;

        $factory = $this->createMock(Factory::class);
        $nodeTypeManager = $this->getNodeTypeManagerMock();
        $nodeTypeManager
            ->expects($this->once())
            ->method('getNodeType')
            ->with($this->equalTo('nt:unstructured'))
            ->will($this->returnValue($nodeType))
        ;
        $propType = new PropertyDefinition($factory, $this->defaultData, $nodeTypeManager);

        $this->assertSame($nodeType, $propType->getDeclaringNodeType());
    }
}
