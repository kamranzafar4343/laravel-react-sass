<?php

namespace App\Http\Controllers;
// dd("Feature1 controller running");

use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use App\Models\UsedFeature;
use Illuminate\Http\Request;

class Feature1Controller extends Controller
{
    public ?Feature $feature = null; 
    public function __construct(){
        $this->feature = Feature::where("route_name", "feature1.index")
            ->where('active', true)
            ->firstorFail();
        
    }

    public function index(){
        return inertia('Feature1/Index', [
            'feature' => new FeatureResource($this->feature),
            'answer' => session('answer')
        ]);
    }

    public function calculate(Request $request){
        $user = $request->user();
        if($user->available_credits < $this->feature->required_credits){
            return back();
        }

        $data = $request->validate([
            'number1' => ['required', 'numeric'],
            'number2' => ['required', 'numeric'],
        ]);

        
        $number1 = (float) $data['number1'];
        $number2 = (float) $data['number2'];
        
        $user->decreaseCredits($this->feature->required_credits);
        
        UsedFeature::create([
            'feature_id' => $this->feature->id,
            'user_id' => $user->id,
            'credits' => $this->feature->required_credits,
            'data' => $data
        ]);

        return to_route('feature1.index')->with('answer', $number1 +
        $number2);
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