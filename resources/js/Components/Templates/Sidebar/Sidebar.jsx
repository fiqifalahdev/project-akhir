import { useState } from "react";
import SidebarMenu from "./SidebarMenu";
import { router } from "@inertiajs/react";

export default function Sidebar() {
    const submit = (e) => {
        e.preventDefault();

        // post(route("logout"));
        router.post(route("logout"));
    };

    return (
        <div className="flex h-screen bg-gray-50 dark:bg-gray-900">
            <aside className="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
                <div className="py-4 text-gray-500 dark:text-gray-400">
                    <a
                        className="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
                        href="#"
                    >
                        TambakkuAdmin
                    </a>

                    <div className="flex flex-col justify-between  h-[90vh]">
                        <div className="menu mt-6">
                            {/* Menampilkan Pengguna yang sudah terdaftar */}
                            <SidebarMenu
                                name="Pengguna"
                                icon="user"
                                routeName="dashboard"
                            />

                            {/* Menampilkan Pengelolaan Pasar Ikan */}
                            <SidebarMenu
                                name="Pasar Ikan"
                                icon="store-alt"
                                routeName="fish-market"
                            />

                            {/* Menampilkan Grafik Harga Ikan */}
                            <SidebarMenu
                                name="Harga Ikan"
                                icon="dollar-circle"
                                routeName="fish-price"
                            />
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    );
}
