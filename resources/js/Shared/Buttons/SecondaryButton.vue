<template>
	<button 
		:type="buttonType"
		:disabled="isDisabled"
		:class="`flex justify-end py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 ${defaultBgColors}`"
		@click="$emit('click')">
		<span><slot></slot></span>
	</button>
</template>

<script>
export default {
	name: 'SecondaryButton',

	props: {
		buttonType: {
			type: String,
			default: 'button'
		},
		disabled: {
			type: Boolean,
			default: false
		},
		defaultBgColors: {
			type: String,
			default: 'bg-main-primary hover:bg-main-secondary active:bg-main-primary'
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
