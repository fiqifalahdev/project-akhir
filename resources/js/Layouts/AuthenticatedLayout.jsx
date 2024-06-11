import { useState } from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import Dropdown from "@/Components/Dropdown";
import NavLink from "@/Components/NavLink";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
import { Link } from "@inertiajs/react";
import Sidebar from "@/Components/Templates/Sidebar/Sidebar";
import Header from "@/Components/Templates/Header/Header";

export default function Authenticated({ user, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="flex h-screen bg-gray-50 dark:bg-gray-900">
            <Sidebar />

            <main className="flex flex-col flex-1 w-full ">
                <div className="h-full overflow-y-auto">
                    <Header />
                    {/* nanti kasih siapa admin yang login */}
                    {/* mungkin bisa di passing variable user diatas */}
                    <div className="container px-6 mx-auto grid">
                        {children}
                    </div>
                </div>
            </main>
        </div>
    );
}
