export class QuestionComment<T> {
    value: T;
    content: string;
    picture: number;

    constructor(options: {
        value?: T,
        content?: string,
        picture?: number
    } = {}) {
        this.value = options.value;
        this.content = options.content || null;
        this.picture = options.picture || null;
    }
}
export class QuestionTag<T> {
    value: T;
    name: string;

    constructor(options: {
        value?: T,
        name?: string
    } = {}) {
        this.value = options.value;
        this.name = options.name || null;
    }
}

export class QuestionPicture<T> {
    value: T;
    title: string;
    description: number;
    picture: any;
    user: number;
    tags: Array<any>;

    constructor(options: {
        value?: T,
        title?: string,
        description?: number,
        picture?: any;
        user?: number;
        tags?: Array<any>
    } = {}) {
        this.value = options.value;
        this.title = options.title || null;
        this.description = options.description || null;
        this.user = options.user || null;
        this.tags = options.tags || [];
    }
}

export class QuestionUser<T> {
    value: T;
    id:number;
    username: string;
    password: string;
    photographerSince: any;
    firstName: string;
    lastName: string;
    cameraModel: string;
    email: string;

    constructor(options: {
        value?: T,
        id?:number;
        username?: string;
        password?: string;
        photographerSince?: any;
        firstName?: string;
        lastName?: string;
        cameraModel?: string;
        email?: string;
    } = {}) {
        this.value = options.value;
        this.id = options.id || null;
        this.username = options.username || null;
        this.photographerSince = options.photographerSince || new Date(options.photographerSince);
        this.firstName = options.firstName || null;
        this.lastName = options.lastName || null;
        this.cameraModel = options.cameraModel || null;
        this.email = options.email || null;
    }
}