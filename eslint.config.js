import eslintConfigPrettier from "eslint-config-prettier";

export default [
    {
        ignores: ["public/**", "vendor/**", "node_modules/**"]
    },
    eslintConfigPrettier,
];
