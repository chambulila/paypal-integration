<template>
	<button :type="buttonType" :disabled="isDisabled" class="px-4 py-3 items-center text-white transform rounded shadow-sm bg-red-primary hover:bg-red-secondary active:bg-red-primary hover:-translate-y-0.5 disabled:cursor-not-allowed" @click="$emit('click')" @submit="$emit('submit')">
		<slot />
	</button>
</template>

<script>
export default {
	name: 'DeleteButton',

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
