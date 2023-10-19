<template>
	<a 
		:href="linkRoute"
		:disabled="isDisabled"
		:class="`py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none rounded-lg border border-gray-400 hover:-translate-y-0.5 hover:bg-gray-200 hover:text-dark-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 ${defaultBgColors}`"
		>
		{{ title }}
	</a>
</template>

<script>
export default {
	name: 'SecondaryLink',

	props: {
		linkRoute: {
			type: String,
			default: '#'
		},
		
		title: {
			type: String,
			default: 'View'
		},
		disabled: {
			type: Boolean,
			default: false
		}
	},

	data() {
		return {
			isDisabled: this.disabled
		};
	},

	watch: {
		disabled(newValue) {
			this.isDisabled = newValue;
		}
	}
};
</script>
