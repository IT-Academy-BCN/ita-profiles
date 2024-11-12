import { describe, it } from 'vitest'
import detailSlice, {
    initialState,
} from '../../../../store/slices/student/detailSlice'
import {
    detailThunk,
    updateDetailThunk,
} from '../../../../store/thunks/getDetailResourceStudentWithIdThunk'

const responseGetDetail = {
    data: {
        id: '123e4567-e89b-12d3-a456-426614174000',
        name: 'Katrine Wyman Jacobson',
        surname: '',
        photo: 'https://example.com/photo.jpg',
        status: 'Active',
        tags: [
            {
                id: 4,
                name: 'HTML&CSS',
            },
        ],
        resume: {
            subtitle: 'Full Stack developer en PHP',
            social_media: {
                github: 'https://github.com/bettie52',
                linkedin: 'https://linkedin.com/abernathy.dayne',
            },
            about: 'Iusto aut debitis soluta facere tempore quisquam. Vel assumenda aliquid quod et eum quos ex. Ipsa ea tempora minima occaecati. Culpa occaecati quod laboriosam reiciendis quia consequuntur.',
        },
    },
}

const payloadUpdateDetail = {
    name: 'Joe',
    surname: 'Doe',
    subtitle: 'Analista de Datos',
    github_url: 'https://github.com/joeDoe',
    linkedin_url: 'https://linkedin.com/joeDoe',
    about: 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum ',
    tags_ids: [3, 7, 9],
}

describe('Student detail Thunk ', () => {
    it('should return initialState', () => {
        expect(
            detailSlice(undefined, {
                type: undefined,
            }),
        ).toEqual(initialState)
    })

    it('should handle detailThunk.pending', () => {
        expect(
            detailSlice(initialState, {
                type: detailThunk.pending.type,
            }),
        ).toEqual({
            ...initialState,
            isLoadingAboutData: true,
        })
    })

    it('should handle detailThunk.rejected', () => {
        expect(
            detailSlice(initialState, {
                type: detailThunk.rejected.type,
            }),
        ).toEqual({
            ...initialState,
            isErrorAboutData: true,
        })
    })

    it('should handle detailThunk.fullfilled', () => {
        expect(
            detailSlice(initialState, {
                type: detailThunk.fulfilled.type,
                payload: responseGetDetail,
            }),
        ).toEqual({
            ...initialState,
            aboutData: responseGetDetail,
        })
    })
})

describe('Update student detail Thunk ', () => {
    it('should handle updateDetailThunk.pending', () => {
        expect(
            detailSlice(initialState, {
                type: updateDetailThunk.pending.type,
            }),
        ).toEqual({
            ...initialState,
            isUpdateLoading: true,
        })
    })

    it('should handle updateDetailThunk.rejected', () => {
        expect(
            detailSlice(initialState, {
                type: updateDetailThunk.rejected.type,
            }),
        ).toEqual({
            ...initialState,
            updatedError: 'Error al realizar la actualizacion del perfil',
        })
    })

    it('should handle updateDetailThunk.fullfilled', () => {
        expect(
            detailSlice(initialState, {
                type: updateDetailThunk.fulfilled.type,
                payload: payloadUpdateDetail,
            }),
        ).toEqual({
            ...initialState,
            updatedMessage: 'El usuario fue actualizado con éxito!',
        })
    })
})
