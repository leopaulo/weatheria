import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";
import eslintPlugin from "vite-plugin-eslint";

export default defineConfig(({ mode }) => {
    let env = loadEnv(mode, process.cwd());
    let PORT = env.VITE_DS_PORT || 3000;

    return {
        server: {
            hmr: {
                host: "localhost",
            },
            port: PORT,
            host: "0.0.0.0",
        },
        plugins: [
            laravel({
                input: ["resources/css/app.css", "resources/js/app.js"],
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            eslintPlugin({ exclude: ["/virtual:/**", "node_modules/**"] }),
        ],
        resolve: {
            alias: {
                vue: "vue/dist/vue.esm-bundler.js",
                resources: path.resolve(__dirname, "resources"),
            },
        },
    };
});
