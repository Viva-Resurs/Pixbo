<?php
namespace App;
use App\ShadowEvent;

trait HasShadowEvents {
	public function shadow_events() {
		return $this->hasMany(ShadowEvent::class);
	}
}
