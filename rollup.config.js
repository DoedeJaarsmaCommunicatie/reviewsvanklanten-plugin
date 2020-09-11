import { nodeResolve } from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import replace from '@rollup/plugin-replace';

export default {
	input: 'assets/scripts/main.js',
	output: [
		{
			file: 'dist/main.js',
			format: 'iife'
		},
		{
			file: 'dist/main.cjs.js',
			format: 'cjs',
		},
		{
			file: 'dist/main.es.js',
			format: 'es'
		}
	],
	plugins: [nodeResolve(), commonjs(), replace({
		'process.env.NODE_ENV': JSON.stringify( 'production' )
	})]
}
