<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureResource extends JsonResource
{

    public static $wrap = false;
    /** 
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */ 
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image ?: null,
            'route_name' => $this->route_name,
            'name' => $this->name,
            'description' => $this->description,
            'required_credits' => $this->required_credits,
            'active' => $this->active,
        ];
    }
}


// ✅ Feature1Controller — Very Simple Explanation
// 1️⃣ index()

// Shows the Feature 1 page.

// Sends the feature data and remaining credits to the frontend.

// 2️⃣ calculate()

// Runs the feature’s logic (your calculation or tool).

// Deducts credits from the user if needed.

// Returns the result back to the page.

// 3️⃣ Why it had a constructor

// To load the Feature (name, cost, active) once.

// To apply auth middleware once.

// To avoid repeating code in both methods.