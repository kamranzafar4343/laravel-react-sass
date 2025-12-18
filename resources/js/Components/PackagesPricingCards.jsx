import { usePage } from "@inertiajs/react";

export default function PackagesPricingCards({ packages, features }) {
    const { csrf_token } = usePage().props;

    return (
        <section className="bg-gray-950 min-h-screen py-4 flex justify-center">
            <div className="w-full max-w-7xl px-4">

                {/* Header */}
                <div className="text-center mb-4 mt-0">
                    <h2 className="text-3xl font-bold text-white tracking-tight">
                        Choose Your Credit Plan
                    </h2>
                    <p className="text-gray-400 text-sm mt-1">
                        Simple, flexible pricing for everyone.
                    </p>
                </div>

                {/* Pricing Grid */}
                <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 mt-2">
                    {packages.map((p) => (
                        <div
                            key={p.id}
                            className="flex flex-col p-5 bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl shadow-lg text-center hover:border-blue-500 transition duration-200"
                        >
                            {/* Package Name */}
                            <h3 className="text-xl font-semibold text-white">
                                {p.name}
                            </h3>

                            {/* Price Row */}
                            <div className="flex justify-center items-end mt-2">
                                <span className="text-4xl font-extrabold text-white">
                                    ${p.price}
                                </span>
                                <span className="ml-1 text-gray-400 text-sm">
                                    / {p.credits} credits
                                </span>
                            </div>

                            {/* Features List */}
                            <ul className="mt-4 mb-6 text-left space-y-2">
                                {features.map((feature) => (
                                    <li
                                        key={feature.id}
                                        className="flex items-center text-gray-300 text-sm"
                                    >
                                        <span className="text-blue-400 mr-2 text-lg">•</span>
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
