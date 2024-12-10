# Magento 2 JWT Authentication Patch

**Fix the JWT authentication vulnerability on certain Magento 2 versions. Deny tokens issued by old encryption key. If you cannot upgrade Magento or cannot apply the official patch, try this one.**

<a href="https://www.wubinworks.com/jwt-auth-patch.html" target="_blank"><img src="https://raw.githubusercontent.com/wubinworks/home/master/images/Wubinworks/JwtAuthPatch/jwt-auth-patch.jpg" alt="Wubinworks Magento 2 JWT Authentication Patch" title="Wubinworks Magento 2 JWT Authentication Patch" /></a>

## Background

In September 2024, an authentication vulnerability was revealed on multiple Magento versions and those versions are identified that a new module `Magento_JwtUserToken` is employed.

Tokens(especially Admin Tokens) issued by **old** encryption key remains valid even if a new key is added. The vulnerability is caused by a bug in the above mentioned module. Attacker who once obtained a key can have **persistent** Admin level WebAPI access to the victim's store.

#### CVE-2024-34102(aka Cosmic Sting) Secondary Disaster

By exploiting CVE-2024-34102, the attacker can steal the encryption key and craft "valid" Admin Token.  
A key rotation without fixing this vulnerability cannot deny the attacker's Admin level access.

#### Do I really need this patch ?

If your store is already hacked or you are unsure if it is, then you **should assume** the encryption key is leaked. Performing an encryption key rotation is very urgent.

## Rotate Encryption Key

_Note1: Perform the key rotation **after** installing this patch(extension)._  
_Note2: Encryption keys are stored in `app/etc/env.php` `crypt/key` path, but **do not delete old keys after rotation**._

 - Login to Admin Panel
 - Go to `System > Other Settings > Manage Encryption Key`
 - Change `Auto-generate a Key` to `Yes` and then `Change Encryption Key`

More details, including command line methods, are in this [blog post](https://www.wubinworks.com/blog/post/magento2-rotate-encryption-key).

We also developed a tool for deployment automation purpose. Check [Magento 2 Encryption Key Manager CLI](#you-may-also-like).

## Requirements

#### For affected versions only

**2.4.4 ~ 2.4.4-p9**  
**2.4.5 ~ 2.4.5-p8**  
**2.4.6 ~ 2.4.6-p6**  
**2.4.7 ~ 2.4.7-p1**

#### Compatibility

This extension does not use `preference`.

## Installation

**`composer require wubinworks/module-jwt-auth-patch`**

## ♥

If you like this extension please star this repository.

## You May Also Like

[Magento 2 patch for CVE-2024-34102(aka Cosmic Sting)](https://github.com/wubinworks/magento2-cosmic-sting-patch)

[Magento 2 Encryption Key Manager CLI](https://github.com/wubinworks/magento2-encryption-key-manager-cli)
