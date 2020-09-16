import { nodeResolve } from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import replace from '@rollup/plugin-replace';
import postcss from 'rollup-plugin-postcss';

export default {
	input: 'assets/scripts/main.js',
	output: [
		{
			file: 'dist/main.js',
			format: 'iife'
		}
	],
	plugins: [nodeResolve(), commonjs(), postcss({
		inject: false,
		extract: true,
		plugins: [
			require('postcss-preset-env'),
			require('postcss-clean')
		]
	}), replace({
		'process.env.NODE_ENV': JSON.stringify( 'production' )
	})]
}
