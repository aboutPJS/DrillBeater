import http from "@/helpers/http.js";

export const loginCall = async (user: {
    name: String,
    email: String,
    password: String,
}) => {
    console.log(user)
    const response = await http().post('/api/login', user);
    return response.data;
};

export const verifyCall = async (userLogin: {
    email: String,
    password: String,
}) => {
    const response = await http().post('/api/login/verify', userLogin);
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

export const getTrainings = async () => {
    const response = await http().get(`api/training`);
    return response.data;
};

export const getTraining = async (id) => {
    const response = await http().get(`api/training/${id}/`);
    return response.data;
};


export const createTraining = async (id) => {
    const response = await http().post(`api/training/workout/${id}/`);
    return response.data;
};

export const completeTraining = async (id) => {
    const response = await http().put(`api/training/${id}/`);
    return response.data;
};

export const updateExecution =
    async (
        data: {
            trainingId: number,
            executionId: number,
            executionData: {
                reps: number,
                sets: number,
                notes: string | null,
                weight: number,
                is_completed: boolean
            }
        }) => {
        const response = await http().put(`api/training/${data.trainingId}/execution/${data.executionId}/`, data.executionData);
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
    alert(error.response.data.message)
    console.log(error)
}