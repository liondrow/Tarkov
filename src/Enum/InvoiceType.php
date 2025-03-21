<?php

namespace App\Enum;

enum InvoiceType: string
{
	case MARKET = "market";
	case SELLER = "seller";
	case User = "user";
	case QUEST = "quest";
}
