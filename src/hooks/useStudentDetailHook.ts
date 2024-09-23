import { useContext, useEffect } from "react";
import { TSmallScreenContext } from "../interfaces/interfaces";
import { useAppDispatch } from "./ReduxHooks";
import { SmallScreenContext } from "../context/SmallScreenContext";
import { useStudentIdContext } from "../context/StudentIdContext";
import getStudenDetail from "../store/reducers/getStudenDetail/studenDetailThunk";
import getStudenProjects from "../store/reducers/getStudenProjects/studenProjectsThunk";
import getStudentLanguages from "../store/reducers/getStudentLanguages/studentLanguagesThunk";

const useStudentDetailHook = (role?: string | null) => {
    const { isMobile }: TSmallScreenContext = useContext(SmallScreenContext)
    const { studentUUID } = useStudentIdContext()
    const studentID = localStorage.getItem("studentID")
    const getStudent = useAppDispatch();

    useEffect(() => {
        if (typeof role === "string" && role === "user") {
            getStudent(getStudenDetail(studentID))
            getStudent(getStudenProjects(studentID))
            getStudent(getStudentLanguages(studentID))
        } else if (!role && studentUUID) {
            getStudent(getStudenDetail(studentUUID))
            getStudent(getStudenProjects(studentUUID))
            getStudent(getStudentLanguages(studentUUID))
        }

    }, [getStudent, role, studentID, studentUUID])

    return { isMobile }
}

export {
    useStudentDetailHook,
}