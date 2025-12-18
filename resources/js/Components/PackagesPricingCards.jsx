import { usePage } from "@inertiajs/react";

export default function PackagesPricingCards({ packages, features }) {
    const { csrf_token } = usePage().props;

    return (
        <section className="bg-gray-100 min-h-screen py-6 flex justify-center">
            <div className="w-full max-w-6xl px-4">

                {/* Header */}
                <div className="text-center mb-6 mt-0">
                    <h2 className="text-3xl font-bold text-gray-800">
                        Choose Your Credit Plan
                    </h2>
                    <p className="text-gray-500 text-sm mt-1">
                        Simple, transparent pricing for everyone.
                    </p>
                </div>

                {/* Pricing Grid */}
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-2">
                    {packages.map((p) => (
                        <div
                            key={p.id}
                            className="flex flex-col p-6 bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition"
                        >
                            {/* Name */}
                            <h3 className="text-xl font-semibold text-gray-800">
                                {p.name}
                            </h3>

                            {/* Price Row */}
                            <div className="flex justify-center items-end mt-3">
                                <span className="text-4xl font-extrabold text-gray-900">
                                    ${p.price}
                                </span>
                                <span className="ml-1 text-gray-500 text-sm">
                                    / {p.credits} credits
                                </span>
                            </div>

                            {/* Features */}
                            <ul className="mt-5 mb-6 text-left space-y-2">
                                {features.map((feature) => (
                                    <li
                                        key={feature.id}
                                        className="flex items-center text-gray-600 text-sm"
                                    >
                                        <span className="text-blue-500 mr-2 text-lg">•</span>
                                        {feature.name}
                                    </li>
                                ))}
                            </ul>

                            {/* Buy Button */}
                            <form method="POST" action={route("credit.buy", p)} className="w-full mt-auto">
                                <input type="hidden" name="_token" value={csrf_token} />
                                <button
                                    type="submit"
                                    className="w-full py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition"
                                >
                                    Buy Credits
                                </button>
                            </form>
                        </div>
                    ))}
                </div>

            </div>
        </section>
    );
}
