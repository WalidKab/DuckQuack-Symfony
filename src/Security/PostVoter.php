<?php

// src/Security/PostVoter.php
namespace App\Security;

use App\Entity\Duck;
use App\Entity\Quack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PostVoter extends Voter
{
    // these strings are just invented: you can use anything

    const EDIT = 'edit';

    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Quack) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $duck = $token->getUser();

        if (!$duck instanceof Duck) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to `supports()`
        /** @var Quack $quack */
        $quack = $subject;

        switch ($attribute) {

            case self::EDIT:
                return $this->canEdit($quack, $duck);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Quack $quack, Duck $duck): bool
    {
        // this assumes that the Post object has a `getOwner()` method
        return $duck === $quack->getAuthor();
    }
}
