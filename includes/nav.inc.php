<nav class="bg-zinc-100 " x-data="{ open: false }">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <!-- Mobile menu button -->
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger menu -->
                    <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Close icon -->
                    <svg x-show="open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Logo and Navigation Links -->
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <!-- Logo -->
                <div class="flex flex-shrink-0 items-center">
                    <a href="index.php" class="text-lg font-extrabold text-gray-900">ABC</a>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <a href="index.php"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-600  hover:text-gray-300">Home</a>
                        <a href="about-us.php"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-600  hover:text-gray-300">About Us</a>
                        <a href="contact-us.php"
                            class="rounded-md px-3 py-2 text-sm font-medium text-gray-600  hover:text-gray-300">Contact Us</a>

                    </div>
                </div>
            </div>

            <!-- Profile or Sign-in Button -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <?php if (isset($user)): ?>
                    <!-- User Profile Dropdown -->
                    <div class="flex justify-center">
                        <div x-data="{ open: false, toggle() { if (this.open) { return this.close(); } this.$refs.button.focus(); this.open = true; }, close(focusAfter) { if (!this.open) return; this.open = false; focusAfter && focusAfter.focus(); } }"
                            x-on:keydown.escape.prevent.stop="close($refs.button)"
                            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                            x-id="['dropdown-button']"
                            class="relative">
                            <!-- Button -->
                            <button x-ref="button" x-on:click="toggle()" :aria-expanded="open"
                                :aria-controls="$id('dropdown-button')" type="button"
                                class="relative items-center">
                                <span><?php echo htmlspecialchars($user["first_name"]) ?></span>
                            </button>
                            <!-- Panel -->
                            <div x-ref="panel" x-show="open" x-transition.origin.top.left
                                x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')" x-cloak
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <a href="user-profile.php"
                                    class="block px-4 py-2 text-sm hover:bg-gray-50 text-gray-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Profile</a>
                                <a href="about-us.php" class="block px-4 py-2 text-sm hover:bg-gray-50 text-gray-700"
                                    role="menuitem" tabindex="-1" id="user-menu-item-1">About Us</a>
                                <a href="sign-out.php"
                                    class="block px-4 py-2 text-sm hover:bg-gray-50 text-gray-700" role="menuitem"
                                    tabindex="-1" id="user-menu-item-2">Sign out</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="text-white bg-zinc-900 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"
                        href="sign-in.php">
                        <button type="submit" class="">Sign in</button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" @click.away="open = false" class="sm:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <a href="index.php"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-400 hover:text-white">Home</a>
            <a href="#"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-400 hover:text-white">Team</a>
            <a href="#"
                class="block rounded-md px-3 py-2 text-base font-medium text-gray-600 hover:bg-gray-400 hover:text-white">Projects</a>

        </div>
    </div>
</nav>

<script defer src="alphineJs/alphine.min.js"></script>