import React from 'react'
import UploadFile from "./UploadFile";

class PodcastForm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            title: '',
            description: '',
        }
    }

    componentDidMount() {
        let {title, description, id} = this.props;

        this.setState({
            title: title,
            description: description,
            id: id
        });
    }

    handleTitleChange = (e) => {
        this.setState({title: e.target.value});
    };

    handleDescriptionChange = (e) => {
        this.setState({description: e.target.value});
    };


    handleSave = (e) => {
        e.preventDefault();
        this.props.handleSave(this.state.title, this.state.description, this.props.id)
    }

    render() {

        let {title, description} = this.state;
        let {image, uploadImage} = this.props;

        return (
            <div>
                <form onSubmit={this.handleSave}>
                    <input type="text" name="title" value={title} onChange={this.handleTitleChange}/>
                    <input type="text" name="description" value={description} onChange={this.handleDescriptionChange}/>
                    <button type="submit">Save</button>
                </form>
                <UploadFile fileType='image' fileLocation={image} uploadFile={uploadImage} />
            </div>
        )
    }
}

export default PodcastForm