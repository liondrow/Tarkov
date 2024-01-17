<?php

namespace App\Enum;

enum QuestStatus: string
{
	case ACTIVE = "active";
	case FINISHED = "finished";
	case QUEUE = "queue";
}
