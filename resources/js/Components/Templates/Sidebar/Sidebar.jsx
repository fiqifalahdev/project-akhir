import { useState } from "react";
import SidebarMenu from "./SidebarMenu";

export default function Sidebar() {
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
                    {/* Menampilkan Grafik Harga Ikan */}
                    <SidebarMenu
                        name="Harga Ikan"
                        icon="dollar-circle"
                        route="dashboard"
                    />
                    {/* Menampilkan Pengguna yang sudah terdaftar */}
                    <SidebarMenu name="Pengguna" icon="user" route="user" />
                </div>
            </aside>
        </div>
    );
}
