import http from "@/helpers/http.js";

export const loginCall = async (phoneNumber: number) => {
    const response = await http().post('/api/login', {phone: phoneNumber});
    return response.data;
};

export const verifyCall = async (credentials: { phoneNumber: number, loginCode: number }) => {
    const response = await http().post('/api/login/verify', {
        phone: credentials.phoneNumber,
        login_code: credentials.loginCode
    });
    return response.data;
};

export const getUser = async () => {
    const response = await http().get('/api/user')
    return response.data;
};

export const getWorkouts = async () => {
    const response = await http().get('/api/workout')
    return response.data;
};

export const getWorkout = async (id) => {
    const response = await http().get(`/api/workout/${id}`)
    return response.data;
};

export const createWorkout = async (data: {
    name: string,
}) => {
    const response = await http().post(`api/workout/`, data);
    return response.data;
};

export const getExercises = async () => {
    const response = await http().get('/api/exercise')
    return response.data;
};

export const addExercise = async (data: { workoutId: number, exerciseId: number }) => {
    const response = await http().post(`api/workout/${data.workoutId}/exercise/${data.exerciseId}`);
    return response.data;
};

export const removeExercise = async (data: { workoutId: number, exerciseId: number }) => {
    const response = await http().delete(`api/workout/${data.workoutId}/exercise/${data.exerciseId}`);
    return response.data;
};

export const createExercise = async (data: {
    name: string,
    description: string | null,
    reps_min: number,
    reps_max: number,
    sets_min: number,
    sets_max: number,
}) => {
    const response = await http().post(`api/exercise/`, data);
    return response.data;
};


export const errorHandling = (error) => {
    console.log(error)
}