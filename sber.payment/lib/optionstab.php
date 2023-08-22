<?php

namespace Sber\Payment;

use Polus\Options\Tab;
use Sber\Payment\Entity\OptionTable;

class OptionsTab extends Tab
{
    public function save(): void
    {
        parent::save();
        OptionTable::getEntity()->cleanCache();
    }
}
