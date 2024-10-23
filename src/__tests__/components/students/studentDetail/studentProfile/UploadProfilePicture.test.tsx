import { describe, expect } from 'vitest';
import { render, screen, fireEvent } from '@testing-library/react';
import { Provider } from 'react-redux';
import { store } from '../../../../../store/store';
import UploadProfilePicture from '../../../../../components/students/studentDetail/studentProfile/studentProfileCards/editStudentProfile/UploadProfilePicture';
import { setToggleProfileImage } from '../../../../../store/slices/student/detailSlice';


describe('UploadProfilePicture Component', () => {

    it('should be defined', () => {
        expect(UploadProfilePicture).toBeDefined();
    });

    it('At first, the modal should not be visible', () => {
        store.dispatch(setToggleProfileImage(false));
        render(
            <Provider store={store}>
                <UploadProfilePicture />
            </Provider>
        );

        expect(screen.queryByRole('form')).not.toBeInTheDocument();
    });

    it('should render the upload form correctly', () => {
        store.dispatch(setToggleProfileImage(true));

        render(
            <Provider store={store}>
                <UploadProfilePicture />
            </Provider>
        );

        expect(screen.getByRole("button", { name: "Cerrar modal" })).toBeInTheDocument();
        expect(screen.getByText('Subir foto de perfil')).toBeInTheDocument();
        expect(screen.getByText('Cancel')).toBeInTheDocument();
        expect(screen.getByText('Aceptar')).toBeInTheDocument();
    });

    it('should open file input when clicking on image', () => {
        store.dispatch(setToggleProfileImage(true));

        render(
            <Provider store={store}>
                <UploadProfilePicture />
            </Provider>
        );

        const imgButton = screen.getByRole('button', { name: 'profilepicture' });
        fireEvent.click(imgButton);

        const fileInput = screen.getByLabelText(/Subir foto/i);
        expect(fileInput).toBeInTheDocument();
    });

    it('should handle file change correctly', () => {
        store.dispatch(setToggleProfileImage(true));
        render(<Provider store={store}><UploadProfilePicture /></Provider>);

        const file = new File(['(⌐□_□)'], 'profile.jpg', { type: 'image/jpeg' });

        const inputFile = screen.getByRole('button', { name: "profilepicture" }) as HTMLInputElement;

        fireEvent.change(inputFile, { target: { files: [file] } });

        expect(inputFile.files?.[0]).toEqual(file);
        expect(inputFile.files?.[0].name).toBe('profile.jpg');
    });

});
