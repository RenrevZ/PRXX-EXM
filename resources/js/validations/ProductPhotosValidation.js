const validatePhotos = (files) => {
    const allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (!Array.isArray(files) || files.length === 0) {
        console.log('files:', files.length)
        return { valid: false, message: 'Please select at least one photo.' };
    }

    if (files.length > 5) {
        return { valid: false, message: 'You can only upload a maximum of 5 photos.' };
    }

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        // Ensure file.name is defined before attempting to split
        if (file.file.name) {
            const extension = file.file.name.split('.').pop().toLowerCase();
            if (!allowedExtensions.includes(extension)) {
                return { valid: false, message: 'Photos must be in JPG, JPEG, or PNG format.' };
            }
        } else {
            // Handle the case where file.name is undefined
            return { valid: false, message: 'File name is undefined.' };
        }
    }

    return { valid: true };
};




export default validatePhotos