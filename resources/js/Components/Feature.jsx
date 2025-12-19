import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, usePage } from "@inertiajs/react";

export default function Feature({ feature, answer, children }) {
    const { auth } = usePage().props;

    const availableCredits = auth.user.available_credits;

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {feature.name}
                </h2>
            }
        >
            <Head title={feature.name} />

            <div className="max-w-7xl mx-auto sm:px lg:px-8">

                {answer !== null && (
                    <div className="mb-3 py-3 px-5 rounded text-white bg-emerald-600 text-xl">
                        Result of calculation: {answer}
                    </div>
                )}

                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg relative">
                    
                    {availableCredits !== null && feature.required_credits > availableCredits && (
                        <div className="absolute left-0 top-0 right-0 bottom-0 z-20 flex flex-col items-center justify-center bg-white/70 gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                strokeWidth="1.5"
                                stroke="currentColor"
                                className="size-6"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"
                                />
                            </svg>

                            <div>
                                You don't have enough credits for this feature.
                                 Go{" "}
                                <Link href="{route('credit.index')}" className="underline">
                                    Buy more credits
                                </Link>
                            </div>
                        </div>
                    )}

                    <div className="p-8 text-gray-400 border-b pb-4">
                        <p>{feature.description}</p>
                        <p className="text-sm italic text-right">
                            Requires {feature.required_credits} credits
                        </p>
                    </div>

                    {children}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}


// ✅ In your project, Feature.jsx is used for one purpose:
// It renders each individual benefit/feature under every pricing package.

// You have many features (like "Fast processing", "Priority support", etc.) stored in the database → sent to frontend → shown inside pricing cards.

// Your pricing card maps like this:

// {features.map((feature) => (
//     <Feature feature={feature} key={feature.id} />
// ))}

// 🔹 So the use of Feature.jsx in your project is:

// To make the pricing page cleaner by displaying each feature in a small reusable component instead of repeating the same UI code.

// 📌 Why it's helpful?

// Avoids writing long repeated <li> code inside the pricing cards

// Makes your UI cleaner and easier to edit

// You can redesign features in ONE place and it updates everywhere

// Example in your UI:

// Your final cards show:

// ✔ Unlimited Access
// ✔ Premium Speed
// ✔ Priority API

// Each checkbox feature comes from Feature.jsx.