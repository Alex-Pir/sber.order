<?php

namespace Sber\Payment;

use Polus\Elastic\Entity\OptionTable;
use Polus\Options\Tab;

class OptionsTab extends Tab
{
    public function save(): void
    {
        parent::save();
        OptionTable::getEntity()->cleanCache();
    }
}
