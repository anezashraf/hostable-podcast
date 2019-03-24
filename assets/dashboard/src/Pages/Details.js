import React from 'react'
import { bindActionCreators } from 'redux'
import PodcastForm from '../Components/Forms/PodcastForm'
import Episodes from '../Components/Episodes'
import { fetchDetails, updateDetails, uploadImage } from '../Reducers/podcast'
import { connect } from 'react-redux'
import PropTypes from "prop-types";

class Details extends React.Component {
  componentDidMount () {
    this.props.fetchDetails()
  }

    handleSave = (title, description) => {
      this.props.updateDetails(title, description)
    };

    render () {
      let { title, description, isLoading, id, image, isImageUploading } = this.props;

      if (isLoading) {
        return null
      }

      return (
        <div className='details'>
          <PodcastForm
            id={id}
            title={title}
            image={image}
            description={description}
            handleSave={this.handleSave}
            uploadImage={this.props.uploadImage}
            isImageUploading={isImageUploading}
          />
          <Episodes />
        </div>
      )
    }
}

Details.propTypes = {
    fetchDetails: PropTypes.func,
    updateDetails: PropTypes.func,
    title: PropTypes.string,
    description: PropTypes.string,
    isLoading: PropTypes.bool,
    id: PropTypes.number,
    image: PropTypes.string,
    isImageUploading: PropTypes.bool,
    uploadImage: PropTypes.func,
};

const mapStateToProps = ({ podcast }) => ({
  title: podcast.title,
  id: podcast.id,
  description: podcast.description,
  image: podcast.image,
  isLoading: podcast.isLoading,
  isImageUploading: podcast.isImageUploading
});

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      fetchDetails,
      uploadImage,
      updateDetails
    },
    dispatch
  );

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Details)
