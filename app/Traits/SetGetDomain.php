<?php

namespace App\Traits;

trait SetGetDomain
{
    /**
     * Get the domain.
     *
     * @param  string  $value
     * @return string
     */
    public function getDomainAttribute($value)
    {
        if ($value) {
            return idn_to_utf8($value, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
        }

        return null;
    }

    /**
     * Set the domain.
     *
     * @param  string  $value
     * @return void
     */
    public function setDomainAttribute($value)
    {
        $this->attributes['domain'] = idn_to_ascii($value, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
    }
}
