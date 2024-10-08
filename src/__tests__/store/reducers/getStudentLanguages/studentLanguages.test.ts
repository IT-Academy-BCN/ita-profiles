import { TLanguage } from "../../../../interfaces/interfaces";
import studentLanguages from "../../../../store/reducers/getStudentLanguages/studentLanguages";

const languagesData: TLanguage[] = []

const initialState = {
    isLoadingLanguages: false,
    isErrorLanguages: false,
    languagesData
}

describe("StudentLanguagesTest reducer", () => {
    it("should be defined", () => {
        expect(studentLanguages).toBeDefined();
    })

    it("should be initialState defined", () => {
        expect(initialState).toBeDefined();
    })

    it("should be return initialState", () => {
        expect(studentLanguages(undefined, {
            type: "object",
            payload: []
        })).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: false,
            languagesData: []
        });
    })


    it("It is expected to return value ​​when the request is pending resolution.", () => {
        expect(studentLanguages(undefined, {
            type: "getStudentLanguagesThunk/pending",
            payload: []
        })).toEqual({
            isLoadingLanguages: true,
            isErrorLanguages: false,
            languagesData: []
        })
    })

    it("It is expected to return values when the request is fulfilled resolution", () => {
        expect(studentLanguages(undefined, {
            type: "getStudentLanguagesThunk/fulfilled",
            payload: {
                language_id: "string",
                name: "string",
                level: "string",
            }
        })).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: false,
            languagesData: {
                language_id: "string",
                name: "string",
                level: "string",
            }
        })
    })

    it("It is expected to return values when the request is rejected resolution", () => {
        expect(studentLanguages(undefined, {
            type: "getStudentLanguagesThunk/rejected",
            payload: []
        })).toEqual({
            isLoadingLanguages: false,
            isErrorLanguages: true,
            languagesData: []
        })
    })
})