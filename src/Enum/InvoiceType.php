<?php

namespace App\Enum;

enum InvoiceType: string
{
	case MARKET = "market";
	case SELLER = "seller";
	case TEAM = "team";
	case QUEST = "quest";
}
