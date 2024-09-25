import { TModality } from "../../../../interfaces/interfaces";
import studentModality from "../../../../store/reducers/getStudentModality/studentModality"
import getStudentModalityThunk from "../../../../store/reducers/getStudentModality/studentModalityThunk"

const modality: TModality[] = [];

describe("studentModality", () => {
    it("should be defined", () => {
        expect(studentModality).toBeDefined()
    })

    it("should be defined getStudentModalityThunk", () => {
        expect(getStudentModalityThunk).toBeDefined()
    })

    it("should be defined const modality type TModality", () => {
        expect(modality).toBeDefined()
    })

    it("should be return initialValues", () => {
        expect(studentModality(undefined, {
            type: "object",
            payload: []
        })).toEqual({
            isLoadingModality: false,
            isErrorModality: false,
            modality: []
        })
    })

    it("It is expected to return value ​​when the request is pending resolution.", () => {
        expect(studentModality(undefined, {
            type: "getStudentModalityThunk/pending",
            payload: []
        })).toEqual({
            isLoadingModality: true,
            isErrorModality: false,
            modality: []
        })
    })

    it("It is expected to return values when the request is fulfilled resolution", () => {
        expect(studentModality(undefined, {
            type: "getStudentModalityThunk/fulfilled",
            payload: {
                "modality": [
                    "Presencial",
                    "Remot"
                ]
            }
        })).toEqual({
            isLoadingModality: false,
            isErrorModality: false,
            modality: [
                "Presencial",
                "Remot"
            ]
        })
    })

    it("It is expected to return values when the request is rejected resolution", () => {
        expect(studentModality(undefined, {
            type: "getStudentModalityThunk/rejected",
            payload: []
        })).toEqual({
            isLoadingModality: false,
            isErrorModality: true,
            modality: []
        })
    })

})
