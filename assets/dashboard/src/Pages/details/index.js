import React from 'react'
import {bindActionCreators} from "redux";
import PodcastForm from '../../Components/Forms/PodcastForm'
import Episodes from '../../Components/Episodes'
import {fetchDetails, updateDetails, uploadImage} from "../../modules/podcast";
import {connect} from "react-redux";


class Details extends React.Component {

    componentDidMount() {
        this.props.fetchDetails();
    }

    handleSave = (title, description) => {
        this.props.updateDetails(title, description);
    };


    render() {

        let {title, description, isLoading, id} = this.props;


        if (isLoading) {
            return null
        }

        return (
            <div className='details'>
                <PodcastForm
                    id={id}
                    title={title}
                    description={description}
                    handleSave={this.handleSave}
                    uploadImage={this.props.uploadImage}
                />
                <Episodes />
            </div>
        );


        return null
    }
}


const mapStateToProps = ({ podcast }) => ({
    title: podcast.title,
    id: podcast.id,
    description: podcast.description,
    isLoading: podcast.isLoading
});

const mapDispatchToProps = dispatch =>
    bindActionCreators(
        {
            fetchDetails,
            uploadImage,
            updateDetails,
        },
        dispatch
    );

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(Details)
