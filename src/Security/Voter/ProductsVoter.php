<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Products;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductsVoter extends Voter
{
    //const voter logic here.
    const EDIT = 'PRODUCT_EDIT';
    const DELETE = 'PRODUCT_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $product): bool
    {
        if(!in_array($attribute, [self::EDIT, self::DELETE])){
            return false;
        }
        if(!$product instanceof Products){
            return false;
        }
        return true;

        //ou //return in_array($attribute, [self::EDIT, self::DELETE]) && $product instanceof Products;
    }

    protected function voteOnAttribute($attribute, $product, TokenInterface $token): bool
    {
        //recuperation de l'utilisateur a partir du token
        $user = $token->getUser();

        if(!$user instanceof UserInterface) return false; //autre facon d'ecrire que les precedentes lignes du dessus

        //verification du role admin de l'utilisateur
        if($this->security->isGranted('ROLE_ADMIN')) return true; //autre facon d'ecrire que les precedentes lignes du dessus
    
        //sinon on verifie ses permissions
        switch ($attribute) {
            case self::EDIT:
                //on verifie ses permissions d'edition
                return $this->canEdit();
                break;
            case self::DELETE:
                //on verifie ses permissions de suppression
                return $this->canDelete();
                break;
        }
    }

    private function canEdit(){
        return $this->security->isGranted('ROLE_PRODUCT_ADMIN');
    }

    private function canDelete(){
        return $this->security->isGranted('ROLE_PRODUCT_ADMIN');
    }
}


