import { Link } from "@inertiajs/react";

export default function Paginator({ meta }) {
    return (
        <div className="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span className="flex items-center col-span-3">
                Showing {meta.to} of {meta.total}
            </span>
            <span className="col-span-2"></span>

            <span className="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul className="inline-flex items-center">
                        {meta.links.map((element, index) => {
                            return (
                                <li key={index}>
                                    <Link
                                        href={element.url}
                                        className={`px-3 py-1 text-white transition-colors duration-150 ${
                                            element.active
                                                ? "bg-purple-600 border-purple-600"
                                                : "dark:text-gray-400 dark:bg-gray-800 border-none"
                                        } border border-r-0  rounded-md focus:outline-none focus:shadow-outline-purple`}
                                    >
                                        {index === 0
                                            ? "Prev"
                                            : index === meta.links.length - 1
                                            ? "Next"
                                            : element.label}
                                    </Link>
                                </li>
                            );
                        })}
                    </ul>
                </nav>
            </span>
        </div>
    );
}
