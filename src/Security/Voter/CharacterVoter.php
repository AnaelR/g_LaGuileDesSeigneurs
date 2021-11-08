<?php

namespace App\Security\Voter;

use App\Entity\Character;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CharacterVoter extends Voter
{
    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_CREATE = 'characterCreate';

    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE
    );

    protected function supports(string $attribute, $subject): bool
    {
        if (null !== $subject) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }
        return in_array($attribute, self::ATTRIBUTES);
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_EDIT', 'POST_VIEW'])
            && $subject instanceof \App\Entity\Character;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        //Defines access tights
        switch ($attribute) {
            case self::CHARACTER_DISPLAY:
                //Peut envoyer $token et $subject pour tester des conditions
                return $this->canDisplay();
                break;
            case self::CHARACTER_CREATE:
                return $this->canCreate();
                break;
        }
        throw new LogicException('Invalid attribute: ' . $attribute);

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'POST_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'POST_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
    /**
     * Check if is allowed to display
     */
    private function canDisplay()
    {
        return true;
    }

    /**
     * Check if is allowed to create
     */
    private function canCreate()
    {
        return true;
    }
}
