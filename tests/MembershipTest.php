<?php


namespace Bitsalt\Membership\Tests;

use Bitsalt\Membership\Membership;
use PHPUnit\Framework\TestCase;

class MembershipTest extends TestCase
{
    public $userData;

    public function setUp(): void
    {
        parent::setUp();
        $this->userData = [
            'username' => 'testy',
            'email' => 'jeff@bitsalt.com',
            'first_name' => 'testy',
            'last_name' => 'McTesterson',
        ];
    }

    public function test_can_return_static_object()
    {
        $mem = Membership::membership();
        $this->assertInstanceOf('Bitsalt\Membership\Membership', $mem);
    }

    public function test_can_add_member()
    {
        $mem = Membership::membership();
        $addResult = $mem->addMember($this->userData);
        $this->assertTrue($addResult, 'Adding with email = '.$this->userData['email']);
    }

    public function test_can_get_user_by_username()
    {
        $mem = Membership::membership();
        $mem->addMember($this->userData);
        $memInfo = $mem->getMember($this->userData['username']);
        $this->assertArrayHasKey('first_name', $memInfo);
    }

    public function test_can_get_member_by_email()
    {
        $mem = Membership::membership();
        $mem->addMember($this->userData);
        $memInfo = $mem->getMember($this->userData['email']);
        $this->assertArrayHasKey('first_name', $memInfo);
    }

    public function test_can_update_member_email()
    {
        $changeMail = 'jimbob@bitsalt.com';
        $mem = Membership::membership();
        $mem->addMember($this->userData);
        $mem->updateMember(['email' => $changeMail]);
        $member = $mem->getMember($changeMail);
        $this->assertEquals($changeMail, $member['email']);
    }

    public function cannot_get_user_with_missing_email()
    {
        $mem = Membership::membership();
        $mem->addMember($this->userData);
        $mem->updateMember();
    }

    public function test_incorrect_email_is_rejected_on_get_member_request()
    {
        $mem = Membership::membership();
        $mem->addMember($this->userData);
        $memInfo = $mem->getMember('testy@testymctesterson.com');
        $this->assertFalse($memInfo);
    }

    public function test_invalid_email_is_rejected_on_get_member_request()
    {
        $mem = Membership::membership();
        $mem->addMember($this->userData);
        $memInfo = $mem->getMember('jackinaroundwithemail@thejack');
        $this->assertFalse($memInfo);
    }

    public function test_invalid_email_is_rejected()
    {
        $this->userData['email'] = 'jackinaroundwithemail@thejack';
        $mem = Membership::membership();
        $added = $mem->addMember($this->userData);
        $this->assertFalse($added, 'Supplied improperly formatted email.');
        //$this->expectException('InvalidArgumentException: User has not been added. Email is invalid.');
    }

}
