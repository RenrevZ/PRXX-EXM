import { useVuelidate } from '@vuelidate/core'
import { required, maxLength } from '@vuelidate/validators'

const validateProduct = (formInput) => {
    const rules = {
        productName: { required, maxLength: maxLength(255) },
        categories: { required, maxLength: maxLength(255) },
        description: { required, maxLength: maxLength(255) }
    }

    return useVuelidate(rules, formInput)
}

export default validateProduct