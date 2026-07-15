<?php

namespace App;

enum UserRole: string
{
    case Admin = 'admin';
    case BoutiqueOwner = 'boutique_owner';
}
