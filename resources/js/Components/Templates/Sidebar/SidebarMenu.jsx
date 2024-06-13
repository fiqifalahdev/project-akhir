import { Link } from "@inertiajs/react";
import "boxicons";
import { BoxIconElement } from "boxicons";

function SelectedMenu({ route }) {
    return route ==
        window.location.pathname.substring(
            window.location.pathname.length,
            1
        ) ? (
        <span
            className="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
            aria-hidden="true"
        ></span>
    ) : null;
}

export default function SidebarMenu({ name, icon, routeName }) {
    return (
        <>
            <ul className="mt-6">
                <li className="relative px-6 py-3">
                    {/* Use this for given route */}
                    <SelectedMenu route={routeName} />
                    <Link
                        className="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                        // href="#" // Ganti sesuai route
                        href={route(routeName)} // Ganti sesuai route
                        // preserveState
                    >
                        <box-icon name={icon} color="white"></box-icon>

                        <span className="ml-4">{name}</span>
                    </Link>
                </li>
            </ul>
        </>
    );
}
