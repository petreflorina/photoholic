import {Injectable} from '@angular/core';
import {Http, Headers, RequestOptions} from '@angular/http';

@Injectable()
export class CommentService {
    constructor(private http: Http) {
    }

    getMany(pictureId: number) {
        return this.http.get('api/picture/' + pictureId + '/comments')
            .map(res => <any> res.json());
    }

    submit(formObject: any) {
        let body = JSON.stringify(formObject);
        let headers = new Headers({'Content-Type': 'application/json'});
        let options = new RequestOptions({headers: headers});

        return this.http.post('api/comment', body, options)
            .map(res => <any> res.json());
    }

    onDelete(commentId: number) {
        let headers = new Headers({'Content-Type': 'application/json'});
        let options = new RequestOptions({body: '', headers: headers});
        return this.http.delete('api/comment/' + commentId, options)
            .map(res => <any> res.json());
    }
}