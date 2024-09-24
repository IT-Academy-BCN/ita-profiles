// const bootcampData: TBootcamp[] = [];

// const getStudentModalityThunk = createAsyncThunk(
//     "getStudentModalityThunk",
//     async (studenSUID: string | null) => {
//         const response = await fetchBootcampData(studenSUID)
//         return response;
//     })

// const studentModality = createSlice({
//     name: "studentModalitySlice",
//     initialState: {
//         isLoadingModality: false,
//         isErrorModality: false,
//         modality: {}
//     },
//     reducers: {},
//     extraReducers: (builder) => {
//         builder.addCase(getStudentModalityThunk.pending, (state) => {
//             state.isLoadingModality = true
//             state.isErrorModality = false
//         })
//         builder.addCase(getStudentModalityThunk.fulfilled, (state, action) => {
//             state.isLoadingModality = false
//             state.isErrorModality = false
//             state.bootcampData = action.payload.bootcamps
//         })
//         builder.addCase(getStudentModalityThunk.rejected, (state) => {
//             state.isLoadingModality = false
//             state.isErrorModality = true
//         })
//     }
// });



describe("studentModality", () => {
    it("should reducer returned defined", () => {
        expect(undefined).toBeDefined()
    })
})