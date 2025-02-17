<?php

namespace BenSampo\Enum\Tests;

use ArrayIterator;
use BenSampo\Enum\Tests\Enums\IntegerValues;
use BenSampo\Enum\Tests\Enums\StringValues;
use BenSampo\Enum\Tests\Enums\UserType;
use PHPUnit\Framework\TestCase;

class EnumComparisonTest extends TestCase
{
    public function test_comparison_against_plain_value_matching()
    {
        $admin = UserType::fromValue(UserType::Administrator);

        $this->assertTrue($admin->is(UserType::Administrator));
    }

    public function test_comparison_against_plain_value_not_matching()
    {
        $admin = UserType::fromValue(UserType::Administrator);

        $this->assertFalse($admin->is(UserType::SuperAdministrator));
        $this->assertFalse($admin->is('some-random-value'));
        $this->assertTrue($admin->isNot(UserType::SuperAdministrator));
        $this->assertTrue($admin->isNot('some-random-value'));
    }

    public function test_comparison_against_itself_matches()
    {
        $admin = UserType::fromValue(UserType::Administrator);

        $this->assertTrue($admin->is($admin));
    }

    public function test_comparison_against_other_instances_matches()
    {
        $admin = UserType::fromValue(UserType::Administrator);
        $anotherAdmin = UserType::fromValue(UserType::Administrator);

        $this->assertTrue($admin->is($anotherAdmin));
    }

    public function test_comparison_against_other_instances_not_matching()
    {
        $admin = UserType::fromValue(UserType::Administrator);
        $superAdmin = UserType::fromValue(UserType::SuperAdministrator);

        $this->assertFalse($admin->is($superAdmin));
    }

    public function test_enum_instance_in_array()
    {
        $administrator = new StringValues(StringValues::Administrator);

        $this->assertTrue($administrator->in([
            StringValues::Moderator,
            StringValues::Administrator
        ]));
        $this->assertTrue($administrator->in([
            new StringValues(StringValues::Moderator),
            new StringValues(StringValues::Administrator)
        ]));
        $this->assertTrue($administrator->in([StringValues::Administrator]));
        $this->assertFalse($administrator->in([StringValues::Moderator]));
    }

    public function test_enum_instance_in_iterator()
    {
        $administrator = new StringValues(StringValues::Administrator);

        $this->assertTrue($administrator->in(new ArrayIterator([
            StringValues::Moderator,
            StringValues::Administrator
        ])));
        $this->assertTrue($administrator->in(new ArrayIterator([
            new StringValues(StringValues::Moderator),
            new StringValues(StringValues::Administrator)
        ])));
        $this->assertTrue($administrator->in(new ArrayIterator([StringValues::Administrator])));
        $this->assertFalse($administrator->in(new ArrayIterator([StringValues::Moderator])));
    }

    public function test_enum_instance_not_in_array()
    {
        $administrator = new StringValues(StringValues::Administrator);

        $this->assertFalse($administrator->notIn([
            StringValues::Moderator,
            StringValues::Administrator
        ]));
        $this->assertFalse($administrator->notIn([
            new StringValues(StringValues::Moderator),
            new StringValues(StringValues::Administrator)
        ]));
        $this->assertFalse($administrator->notIn([StringValues::Administrator]));
        $this->assertTrue($administrator->notIn([StringValues::Moderator]));
    }

    public function test_enum_instance_not_in_iterator()
    {
        $administrator = new StringValues(StringValues::Administrator);

        $this->assertFalse($administrator->notIn(new ArrayIterator([
            StringValues::Moderator,
            StringValues::Administrator
        ])));
        $this->assertFalse($administrator->notIn(new ArrayIterator([
            new StringValues(StringValues::Moderator),
            new StringValues(StringValues::Administrator)
        ])));
        $this->assertFalse($administrator->notIn(new ArrayIterator([StringValues::Administrator])));
        $this->assertTrue($administrator->notIn(new ArrayIterator([StringValues::Moderator])));
    }

    /**
     * @test
     * Verify that relational comparision of Enum object uses attribute `$value`
     *
     * "comparison operation stops and returns at the first unequal property found."
     * as stated in https://www.php.net/manual/en/language.oop5.object-comparison.php#98725
     * @return void
     */
    public function test_object_relational_comparison()
    {
        $b = IntegerValues::B();
        $a = IntegerValues::A();

        $this->assertTrue($a > $b);
    }
}
