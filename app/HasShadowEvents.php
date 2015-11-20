<?php
namespace App;

trait HasShadowEvents {
	public function event_shadows() {
		return $this->hasMany(ShadowEvent::class);
	}
}
